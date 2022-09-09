#!/bin/bash
docker build -t workflows/phpcs `pwd -W`/workflows
docker run --rm -v `pwd -W`:/app workflows/phpcs phpcbf --standard=PSR12 app/ -n