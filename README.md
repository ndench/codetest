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

I wrote this using ansible and PHP because I felt it was more relevant.
You can just run any server that can run PHP, but the following instructions are how I set up my dev environment.

TODO: instructions on how to run PHP internal server instad of setting up dev enviroment

## Things to install
* vagrant
* virtualbox
* ansible

## Starting the virtual machine
Running `vagrant up` will bring up the VM. It will download the base ubuntu box, run some update scripts,
then run some ansible provisioning to set it up for the project.

You might get an error saying that an IP address cannot be assigned. There is a 
(known problem)[https://github.com/mitchellh/vagrant/issues/7138#issuecomment-196786583] and can be resolved
by running:

```
vagrant halt
vagrant up
```

If you had problems bringing up the VM, you might need to manually provision it as well. 

```
vagrant provision
```


## Accessing the service

Once the VM is up and running, you can access it at http://localhost:13001.

