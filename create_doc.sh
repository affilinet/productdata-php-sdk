#!/usr/bin/env bash

# @see https://github.com/ApiGen/ApiGen/wiki/Generate-API-to-Github-pages-via-Travis

vendor/bin/apigen generate -s ./src -d ./docs
