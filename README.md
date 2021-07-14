# Game of thrones API

Game of thrones characters API.

## Getting Started

### Install

Clone the repository and execute
```
make up
```
After that, execute
```
make install
```

Your app will be running on 127.0.0.1:80. If you want to run it with a host, just add it to your host file
```
127.0.0.1       local.got.test
```

## Commands

Execute the next command to list the commands available
```
make help
```

## Testing and coverage
To generate the code reports, execute the next command. The report files will be generated on /app/test/report
```
make test-coverage
```

## Elasticsearch
In order for elasticsearch to work, you must execute this in your machine (Linux):
```
sysctl -w vm.max_map_count=262144
```
The elasticsearch data can be populated using the command:
```
make populate-elastic
```

## Author
- Alberto Martínez Hernández
