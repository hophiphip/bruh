#!/bin/sh

host=localhost:9200

usage=$(cat <<-END
Usage:
    Wait for Elasticsearch to start receiving requests.
    Reference: https://www.elastic.co/guide/en/elasticsearch/reference/current/cluster-health.html
      $(basename "$0") -h [HOST]

      -h, --host        full hostname (default: localhost:9200)
      --help            display help message
END
)

while [ "$#" -gt 0 ]; do
    case $1 in
        -h|--host) host="$2"; shift ;;
        --help) echo "$usage"; exit 1 ;;
        *) echo "Unknown parameter: $1"; echo "$usage"; exit 1 ;;
    esac
    shift
done

while ! curl "$host"/_cluster/health?wait_for_status=yellow 1>/dev/null 2>/dev/null; do
    echo "Waiting for $host"
    sleep 2
done

echo "Done waiting for $host"