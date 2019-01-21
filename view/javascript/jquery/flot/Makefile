<<<<<<< Upstream, based on origin/master
# Makefile for generating minified files

.PHONY: all

# we cheat and process all .js files instead of an exhaustive list
all: $(patsubst %.js,%.min.js,$(filter-out %.min.js,$(wildcard *.js)))

%.min.js: %.js
	yui-compressor $< -o $@

test:
	./node_modules/.bin/jshint *jquery.flot.js
=======
<<<<<<< HEAD
# Makefile for generating minified files

.PHONY: all

# we cheat and process all .js files instead of an exhaustive list
all: $(patsubst %.js,%.min.js,$(filter-out %.min.js,$(wildcard *.js)))

%.min.js: %.js
	yui-compressor $< -o $@

test:
	./node_modules/.bin/jshint *jquery.flot.js
=======
# Makefile for generating minified files

.PHONY: all

# we cheat and process all .js files instead of an exhaustive list
all: $(patsubst %.js,%.min.js,$(filter-out %.min.js,$(wildcard *.js)))

%.min.js: %.js
	yui-compressor $< -o $@

test:
	./node_modules/.bin/jshint *jquery.flot.js
>>>>>>> origin/master
>>>>>>> 0ccdbb6 Фиксация 21,01,2019
