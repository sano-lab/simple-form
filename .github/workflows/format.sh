#!/bin/bash
docker build --no-cache -t workflows/phpcs `pwd -W`/.github/workflows
docker run --rm -v `pwd -W`:/app workflows/phpcs php ../phpcbf.phar --standard=PSR12 app/ -n

# Debug
#docker run -it  -v C:/Users/2190347/Desktop/simple-form:/app workflows/phpcs /bin/bash