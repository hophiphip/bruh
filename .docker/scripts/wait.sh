#!/bin/sh

# NOTE: printf "" 2>>/dev/null >>/dev/tcp/{IP}/{PORT} can be an alternative when there is no `nc` binary installed

host=localhost
port=80

usage=$(cat <<-END
Usage:
    Wait for specific port on host to start listening for connections.
      $(basename "$0") -h [HOST] -p [PORT]

      -h, --host        hostname (default: localhost)
      -p, --port        port for host (default: 80)
      --help            display help message
END
)

while [ "$#" -gt 0 ]; do
    case $1 in
        -h|--host) host="$2"; shift ;;
        -p|--port) port="$2"; shift ;;
        --help) echo "$usage"; exit 1 ;;
        *) echo "Unknown parameter: $1"; echo "$usage"; exit 1 ;;
    esac
    shift
done

while ! nc -z "$host" "$port"; do
    echo "Waiting for $host:$port"
    sleep 2
done

echo "Done waiting for $host:$port"