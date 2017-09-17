# codetest

# To run the external lotto server

This project exists to serve as the server component of a code test. The project serves a HTTP json response from URL [http://localhost:8080](http://localhost:8080). The [response](json/response.json) will contain lotteries, game types and game offers.

The json document is in the /json directory of this project.

The project is written in golang. To build and run the example you will need to install [docker](https://docs.docker.com/engine/installation/).

## Build
Before you run the container you need to build the source code for the conainer.

### Container build

Creates a statically linked binary for linux because docker runs under linux.

```bash
 ./build.sh
```

## Run
The program runs in docker and exposes the service on port :8080 on localhost.

```bash
 ./run.sh
```

To access [http://localhost:8080](http://localhost:8080)

## Development

### Git 
Add git hooks
```bash
ln -s `pwd`/hooks/pre-commit .git/hooks
```

### Local build

```bash
go get -v ./... && go build -v
```

# To run the customers service

You can just run any server that can run PHP, but the following instructions are how I set up my dev environment.

## Things to install
* [vagrant](https://www.vagrantup.com/docs/installation/)
* [virtualbox](https://www.virtualbox.org/manual/ch02.html)
* [ansible2](https://docs.ansible.com/ansible/latest/intro_installation.html)

## Starting the virtual machine
Running `vagrant up` will bring up the VM. It will download the base ubuntu box, run some update scripts,
then run ansible provisioning to set it up for the project.

You might get an error saying that an IP address cannot be given to the NFS helper. There is a 
(known problem)[https://github.com/mitchellh/vagrant/issues/7138#issuecomment-196786583] and can be resolved
by restarting the vagrant box:

```bash
vagrant halt
vagrant up
```

If you had problems bringing up the VM, you might need to manually provision it as well. 

```bash
vagrant provision
```

## Composer install
You will then need to install composer dependencies

```bash
vagrant ssh
cd /srv/www/codetest
php composer.phar global require "fxp/composer-asset-plugin:^1.3.1"
php composer.phar install
```

## Running tests
You can run PHPUnit tests from `/srv/www/codetest`:

```bash
vendor/bin/phpunit
```

This will build code coverage report in html, located in `tests/_output`.


## Accessing the service

Once the VM is up and running, you can access it at http://localhost:13001.


# Reasoning behind my implementation

I wrote this using Yii and provisioned the vm using ansible because I felt it was more relevant.
I've never done Yii before so I thought this was a good opportunity to learn.

Instead of just hitting the API and sending json data through to the view, I parsed the date into objects
and validated them. I feel like this is a better approach because I can be sure of the format.

I only got the raffle tickets displaying and chose not to implement the lottery tickets because
I had already spent more than 4 hours learning the framework and testing out different implementations.
If I had implemented the lottery tickets it would have been exactly the same, with a bunch of models
knowing how to build themselves from an array, and using the HTML helpers to display them in tables.

## Things I could do better next time

I tried getting JMS Serializer to automatically deserialize the json to my models, however this
proved to be quite difficult. Especially because the models are all nested, and because I wanted
to be able to store the nested models separately so I could access a single Lottery or Draw for instance.
It would remove a lot of code duplication if I got JMS Serializer configured correctly.

I would also like to cache the data in the LotteryClient using Redis. It is unecessary to be
hitting the api and rebuilding all the data on every page load.

I would have preferred the urls to be prettier with `site/draws/274` instead of `site/draws?number=274`,
I just needed to spend more time understanding Yii routing to accomplish this.
