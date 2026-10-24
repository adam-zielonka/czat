"""Verify rejected requests before any database access is attempted."""
from pathlib import Path
import socket
import subprocess
import time
import urllib.error
import urllib.request

with socket.socket() as probe:
    probe.bind(('127.0.0.1', 0))
    port = probe.getsockname()[1]
root = Path(__file__).resolve().parents[1]
server = subprocess.Popen(['php', '-S', f'127.0.0.1:{port}', '-t', str(root / 'src')],
                          stdout=subprocess.DEVNULL, stderr=subprocess.DEVNULL)
try:
    for _ in range(50):
        try:
            with socket.create_connection(('127.0.0.1', port), timeout=.1):
                break
        except OSError:
            time.sleep(.05)
    cases = [('/index.php?strona=../../install', 'GET', 404),
             ('/index.php?strona=function.login', 'GET', 405),
             ('/index.php?strona=function.login', 'POST', 403),
             ('/install.php', 'GET', 403)]
    for path, method, expected in cases:
        request = urllib.request.Request(f'http://127.0.0.1:{port}{path}',
                                         method=method, data=b'' if method == 'POST' else None)
        try:
            with urllib.request.urlopen(request, timeout=5) as response:
                status = response.status
        except urllib.error.HTTPError as error:
            status = error.code
        assert status == expected, (path, status, expected)
    print('HTTP traversal, method, CSRF and installer regressions passed.')
finally:
    server.terminate()
    server.wait(timeout=5)
