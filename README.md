# SimplePie 2.0

This is the 2.0 branch of SimplePie. The point of this release is to rip out all of the non-essential crap and focus exclusively on the parser itself.

This is not your mother's SimplePie. We've ripped out fetching, caching and HTML sanitization — and that's just to start. You'll need to find other classes to do those things instead.


## Authors and contributors
### Current
* [Geoffrey Sneddon](http://gsnedders.com) (Lead developer)

### Contributors
For a complete list of contributors:

1. Pull down the latest SimplePie code
2. In the `simplepie` directory, run `git shortlog -ns`


## Requirements
* PHP 5.1.4 or newer
* libxml2 (certain 2.7.x releases are too buggy for words, and will crash)
* Either the iconv or mbstring extension
* cURL or fsockopen()
* PCRE support


## License
[New BSD license](http://www.opensource.org/licenses/bsd-license.php)


## Need support?
For further setup and install documentation, function references, etc., visit:
[http://simplepie.org/wiki/](http://simplepie.org/wiki/)

For bug reports and feature requests, visit:
[http://github.com/rmccue/simplepie/issues](http://github.com/rmccue/simplepie/issues)

Support mailing list -- powered by users, for users.
[http://tech.groups.yahoo.com/group/simplepie-support/](http://tech.groups.yahoo.com/group/simplepie-support/)
