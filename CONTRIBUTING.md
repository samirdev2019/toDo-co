# TodoList&co project contribution

Thanks for your interest in ToDO& co project!

This document is about issues and pull requests and Code reviews.to know how to install the project look [the readme file](https://github.com/samirdev2019/toDo*co) 

## Summary

*   [Issues](#issues)  
*   [Pull Requests](#pull-requests)  
*   [Coding style](#Coding-style)  
*   [Code Reviews](#code-reviews)  

## Issues

First, check if you are up to date: is your version still supported, and are
you using the latest good version of application?

GitHub Issues is for **issues**, as opposed to question on how to use TodoList&co application.
If you are not sure this is a bug, or simply want to ask such a question,
please post your question on this email[allabsamir666@gmail.com](allabsamir666@gmail.com)

If you happen to find a bug, we kindly request you report it.

Then, if it appears that it is indeed a real bug, you may report it using
Github by following these points are taken care of:

*   Check if the bug is not already reported.

*   The title sums up the issue with clarity.

*   A description of the workflow needed to reproduce the bug. Please try to make sentences, dumping an error message by itself is frowned upon.

*   If your issue is an error page,**Do not** make a screenshot of the stack trace, as screenshots are not indexed by search engines and will make it difficult for other people to find your bug report.

*   Screenshots should be considered additional data, and therefore, you should always provide a textual description of the bug. It is strongly recommended to provide them when reporting UI related bugs.

*   Don't hesitate to give as much information as you can (OS, PHP
version, extensions...).
 
## Pull Requests

All the TodoList&co team will be glad to review your code changes propositions! :smile:

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

Please note that we try to keep phpdoc to a minimum, so if an `@param` phpdoc
comment brings nothing more than the type hint and variable name already do,
it can be removed. Descriptions are optional if you want to document a type.

```php
/**
 * @param Bar|Baz $foo
 * @param int     $limit a crucial, highly interesting comment
 */
protected function bar($foo, string $name, int $limit)
{
    // ...
}
```

Please also note that multiline signatures are allowed when the line is longer than 120 characters.

#### The tests

If your PR contains a fix, tests should be added to prove the bug.

If your PR contains an addition, a new feature, this one has to be fully covered by tests.

Some rules have to be respected about the test:

*   All test methods must be prefixed by `test`. Example: `public function testCreateUser()`.
*   As opposed, the `@test` annotation is prohibited.
*   All test method names must be in camel case format.
*   Most of the time, the test class should have the same name as the targeted class, suffixed by `Test`.

### Writing a Pull Request

#### The subject

Ideally, a Pull Request should concern one and **only one** subject, so that it
remains clear, and independent changes can be merged quickly.

If you want to fix a typo and improve the performance of a process, you should
try as much as possible to do it in a **separate** PR, so that we can quickly
merge one while discussing the other.

The goal is to have a clear commit history and make a possible revert easier.

If you found an issue while writing your change that is not related to
your work, please do another PR for that. In some rare cases, you might be
forced to do it on the same PR. In this kind of situation, please add a comment on your PR explaining why you feel it is the case.

##### Dependency changes

If you want to change some dependencies, here are the rules:

*   Don't add support for a version lower than the current one.
*   Don't change the highest supported version to a lower one.

##### Legacy branches

Legacy branches are **NOT** supported at all. Any submitted Pull Request will be immediately closed.

Core team members *may* cherry*pick some fixes from the stable branch to the legacy one if it's really needed
and if the legacy one is not too old (~less than one month).

#### The commit message

TodoList&co is a project with many contributors, and a big part of the job is
being able to understand the code at all times, be it when submitting a PR or
looking at the history. Good commit messages are crucial to achieve this goal.

To sum them up, the commit message has to be crystal clear and of course,
related to the PR content.

The first line of the commit message must be short, keep it under 50
characters. It must say concisely but *precisely* what you did. The other
lines, if needed, should contain a complete description of *why* you did this.

Bad commit message subject:

```
Update README.md
```

Good commit message subject :

```bash
Document how to install the project
```

 in the commit description, explain why you did that and how it fixes
something.
```bash
call foo::bar() instead of bar::baz()

This fixes a bug that arises when doing this or that, because baz() needs a
flux capacitor object that might not be defined.
Fixes #5
```
Good commit message with description :

```bash
change color button delete to red
```
## Code Reviews

Codacy is used for this application then grooming a PR until it is ready to get merged is a contribution by itself.
Indeed, why contribute a PR if there are hundreds of PRs already waiting to get reviewed and hopefully, merged?
By taking up this task, you will try to speed up this process by making sure the merge can be made with peace of mind.

### Commenting on a PR

Before doing anything refrain to dive head-first in the details of the PR and try to see the big picture,
to understand the subject of the PR. If the PR fixes an issue, read the issue first.
This is to avoid the pain of making a reviewer rework their whole PR and then not merging it.

### Labelling the PR

Applying labels requires write access to PRs, but you can still advise if you do not have them.
There are several labels that will help determine what the next version number will be.
Apply the first label that matches one of this conditions, in that order:

*   `major`: there is a BC break. The PR should target the `master` branch.
*   `minor`: there is a backwards compatible change in the API. The PR should target the stable branch.
*   `patch`: this fixes an issue (not necessarily reported). The PR should target the stable branch.
*   `docs`: this PR is solely about the docs. `pedantic` is implied.
*   `pedantic`: this change does not warrant a release.

Also if you see that the PR lacks documentation, tests, a changelog note,
or an upgrade note, use the appropriate label.

### Merging

Do not merge something you wrote yourself. Do not merge a PR you reviewed alone, instead, merge PRs that have already be reviewed and approved by another reviewer.

### Be nice to the contributor

Thank them for contributing. Encourage them if you feel this is going to be long.
In short, try to make them want to contribute again. If they are stuck, try to provide them with
code yourself, or ping someone who can help.

## Manual merges

The Stable branches are regularly merged into master branches.
It is great when it works, but often, there will be git conflicts and a human
intervention will be needed. Let us assume we are working on a repository where
the stable branch is 1.X. To do the merge manually, follow these steps:
1. Fetch the latest commits: `git fetch --all`
2. Checkout the master branch, and make sure it is up to date:
   `git checkout -B master origin/master`
3. Proceed with the merge: `git merge origin/1.X`
4. Fix the conflicts (if you are doing this, it is because of conflicts,
   right?) `git mergetool`
5. Create a merge commit `git commit`
6. Push the result to your fork: `git push fork 1.X`
7. Create a pull request from `fork/1.X` to `origin/1.X`
8. When the PR can be merged, do not merge it. Instead, use
   `git push origin 1.X`.
