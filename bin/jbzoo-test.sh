#!/usr/bin/env sh

echo ""
echo ">>> >>> PHPUnit Joomla"
./bin/phpunit   --configuration ./phpunit-joomla.xml.dist

echo ""
echo ">>> >>> PHPUnit Wordpress"
./bin/phpunit   --configuration ./phpunit-wordpress.xml.dist

echo ""
echo ">>> >>> PHPUnit Utility"
./bin/phpunit   --configuration ./phpunit-utility.xml.dist      ./tests/unit/utility/CodeStyleTest.php

echo ""
echo ">>> >>> PHP Statistics"
./bin/phpmd  ./src/jbzoo                            \
    text                                            \
    ./src/jbzoo/vendor/jbzoo/misc/phpmd/jbzoo.xml   \
    --verbose

./bin/phpcs  ./src/jbzoo                                                \
    --extensions=php                                                    \
    --standard=./src/jbzoo/vendor/jbzoo/misc/phpcs/JBZoo/ruleset.xml    \
    --report=full

./bin/phpcpd ./src/jbzoo

./bin/phploc ./src/jbzoo --verbose
