# TodoList&co project contribution

Thanks for your interest in ToDO& co project!

This document is about issues and pull requests and Code reviews.to know how to install the project look [the readme file](https://github.com/samirdev2019/toDo-co) 

## Summary

*   [Issues](#issues)  
*   [Pull Requests](#pull-requests)  
*   [Coding style](#Coding-style)  
*   [Code Reviews](#code-reviews)  

## Issues

If you happen to find a bug, we kindly request you report it, then.

*   Check if the bug is not already reported.

*   The title sums up the issue with clarity.

*   you must always provide a textual description of the bug. Screenshots should be considered as additional data.

*   Don't hesitate to give as much information as you can (OS, PHP
version, extensions).
 
## Pull Requests

All the TodoList&co team will be glad to review your code changes propositions!

But please, read the following before.

### The content

#### Coding style

Each project follows [PSR*1](http://www.php*fig.org/psr/psr*1/), [PSR*2](http://www.php*fig.org/psr/psr*2/)
and [Symfony Coding Standards](http://symfony.com/doc/current/contributing/code/standards.html) for coding style,
[PSR*4](http://www.php*fig.org/psr/psr*4/) for autoloading.

Please [install php_codesniffer Standard Fixer](https://packagist.org/packages/squizlabs/php_codesniffer)
and run this command before committing your modifications:

```bash
./vendor/bin/phpcs
./vendor/bin/phpcbf
```

Please note that we try to keep phpdoc.

## Code Reviews

Codacy is used to allow the analysis and tracking of code quality with each commit or pull requeste.
correct errors related to your newly added functions to keep the application's debt stability

#### The tests

If your pull request contains an addition, a new feature, this one has to be minimum 70% covered by tests.

Some rules have to be respected about the test:

*   All test methods must be prefixed by `test`. Example: `public function testCreateUser()`.
*   All test method names must be in camel case format.
*   Most of the time, the test class should have the same name as the targeted class, suffixed by `Test`.

### Writing a Pull Request

#### The subject

the pull request should concern one and **only one** subject, so that it remains clear, and it can be merged quickly.

##### Dependency changes

If you want to change some dependencies:

*   Don't add support for a version lower than the current one symfony 3.4.*.

#### The commit message

TodoList&co is a project with many contributors,
the commit message has to be crystal clear and of course,
related to the PR content.

Bad commit message subject:

```bash
Update README.md
```

Good commit message subject :

```bash
Document how to install the project
```

Good commit message with description :

```bash
change color button delete to red
```

### Commenting on a pull request

Before commenting, try to see the details of the pull request and try to see the situation as a whole, to understand the subject of the PR. If the PR fixes an issue, read the issue first.
This is to avoid the pain of making a reviewer rework their whole PR and then not merging it.

### Merging

the PR will be reviewed and approved by another reviewer. so do not merge something you wrote yourself.

### Be nice to the contributor

Thank them for contributing.