PHPGithook - Example module
---------------------------

This is a module, to show off what PHPGithook can do.

### How to create a module

First of all you MUST have a file with the name `Setup.php` and this file must implement `PHPGithook\ModuleInterface\PHPGithookSetupInterface`

You must require [`phpgithook/module-interface`](https://github.com/phpgithook/module-interface) in your composer file, to get access to the interfaces.

You do not need to create a file for all git hooks, you can just create those you want, you can also put everything inside the `Setup.php` file if you want.

### How to test a module

You can require [`phpgithook/module-tester`](https://github.com/phpgithook/module-tester) in your composer dev requirements, and create a test file which extends `PHPGithook\ModuleTester\ModuleTester` and implement the abstract method, with the path to your `Setup.php` file.

If you don't implement all the git hooks, a warning will be thrown, if its intentionally these warnings can ofcourse be ignored.

### Install

As this is a example module, it shouldn't be used - but you can ofcourse use it if you want.

Install it with `composer require phpgithook/module-hello-world`

And to activate it, you must run `vendor/bin/phpgithook phpgithook:module:enable helloworld`
