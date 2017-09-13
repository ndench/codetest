# -*- mode: ruby -*-
# vi: set ft=ruby :

Vagrant.configure("2") do |config|
  config.vm.box = "ubuntu/xenial64"

  config.vm.network "forwarded_port", guest: 80, host: 13001 # nginx

  config.vm.network "private_network", type: "dhcp"
  config.vm.synced_folder "src", "/srv/www/codetest", type: "nfs", mount_options: ["tcp", "actimeo=2"]

  config.vm.provider "virtualbox" do |vb|
    vb.name = "codetest"
    vb.memory = 2048
  end

  config.vm.provision "ansible" do |ansible|
    ansible.playbook = "provisioning/playbook.yml"
    ansible.groups = {
        "dev" => ["default"]
    }
    ansible.verbose = "v"
  end
end
