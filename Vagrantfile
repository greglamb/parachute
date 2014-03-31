# -*- mode: ruby -*-
# vi: set ft=ruby :

# Config Github Settings
github_username = "greglamb"
github_repo     = "Vagrantfile"
github_branch   = "master"

# Server Configuration

# Set a local private network IP address.
# See http://en.wikipedia.org/wiki/Private_network for explanation
# You can use the following IP ranges:
#   10.0.0.1    - 10.255.255.254
#   172.16.0.1  - 172.31.255.254
#   192.168.0.1 - 192.168.255.254
server_ip             = "192.168.33.10"
server_memory         = "512" # MB
server_timezone       = "UTC"

# Database Configuration
mysql_root_password   = "password"   # We'll assume user "root"
mysql_version         = "5.5"    # Options: 5.5 | 5.6
mysql_enable_remote   = "true"  # remote access enabled when true
pgsql_root_password   = "password"   # We'll assume user "root"
mariadb_version       = "10.0"   # Options: 5.5 | 10.0
mariadb_root_password = "password"   # We'll assume user "root"
firebird_sysdba_password = "masterkey"

# Languages and Packages
ruby_version          = "latest" # Choose what ruby version should be installed (will also be the default version)
ruby_gems             = [        # List any Ruby Gems that you want to install
  #"jekyll",
  #"sass",
  #"compass",
]
php_version           = "latest" # Options: latest|previous|distributed   For 12.04. latest=5.5, previous=5.4, distributed=5.3
composer_packages     = [        # List any global Composer packages that you want to install
  "phpunit/phpunit:4.0.*",
  #"codeception/codeception=*",
  #"phpspec/phpspec:2.0.*@dev",
]
public_folder         = "/vagrant/public" # If installing Symfony or Laravel, leave this blank to default to the framework public directory
nodejs_version        = "latest"   # By default "latest" will equal the latest stable version
nodejs_packages       = [          # List any global NodeJS packages that you want to install
  #"grunt-cli",
  #"gulp",
  #"bower",
  #"yo",
  #"brunch",
]

Vagrant.configure("2") do |config|

  # Set server to Ubuntu 12.04
  config.vm.box = "precise64"

  config.vm.box_url = "http://files.vagrantup.com/precise64.box"

  config.vm.provider :parallels do |parallels, override|
      # Provided by https://github.com/Parallels/vagrant-parallels
      config.vm.box = "parallels/ubuntu-12.04"
  end

  config.vm.provider "vmware_fusion" do |vmware, override|
      override.vm.box_url = "http://files.vagrantup.com/precise64_vmware.box"
  end

  #### TODO: Can I make this work for Microsoft Hyper-V ?
  # Options for libvirt vagrant provider.
  #config.vm.provider :libvirt do |libvirt|
  #
  #  # A hypervisor name to access. Different drivers can be specified, but
  #  # this version of provider creates KVM machines only. Some examples of
  #  # drivers are qemu (KVM/qemu), xen (Xen hypervisor), lxc (Linux Containers),
  #  # esx (VMware ESX), vmwarews (VMware Workstation) and more. Refer to
  #  # documentation for available drivers (http://libvirt.org/drivers.html).
  #  libvirt.driver = "qemu"
  #
  #  # The name of the server, where libvirtd is running.
  #  libvirt.host = "localhost"
  #
  #  # If use ssh tunnel to connect to Libvirt.
  #  libvirt.connect_via_ssh = false
  #
  #  # The username and password to access Libvirt. Password is not used when
  #  # connecting via ssh.
  #  libvirt.username = "root"
  #  #libvirt.password = "secret"
  #
  #  # Libvirt storage pool name, where box image and instance snapshots will
  #  # be stored.
  #  libvirt.storage_pool_name = "default"
  #end

  if Vagrant.has_plugin?("vagrant-cachier")
    config.cache.auto_detect = true
    config.cache.scope = :box
    # If you are using VirtualBox, you might want to enable NFS for shared folders
    # config.cache.enable_nfs  = true
  end

  # Create a hostname, don't forget to put it to the `hosts` file
  # This will point to the server's default virtual host
  # TO DO: Make this work with virtualhost along-side xip.io URL
  config.vm.hostname = "vaprobash.dev"

  # Create a static IP
  config.vm.network :private_network, ip: server_ip

  # Use NFS for the shared folder
  config.vm.synced_folder ".", "/vagrant",
            id: "core",
            :nfs => true,
            :mount_options => ['nolock,vers=3,udp,noatime']

  # If using VirtualBox
  config.vm.provider :virtualbox do |vb|

    # Set server memory
    vb.customize ["modifyvm", :id, "--memory", server_memory]

    # Set the timesync threshold to 10 seconds, instead of the default 20 minutes.
    # If the clock gets more than 15 minutes out of sync (due to your laptop going
    # to sleep for instance, then some 3rd party services will reject requests.
    vb.customize ["guestproperty", "set", :id, "/VirtualBox/GuestAdd/VBoxService/--timesync-set-threshold", 10000]

    # Prevent VMs running on Ubuntu to lose internet connection
    # vb.customize ["modifyvm", :id, "--natdnshostresolver1", "on"]
    # vb.customize ["modifyvm", :id, "--natdnsproxy1", "on"]

  end

  # If using Parallels
  config.vm.provider :parallels do |parallels, override|

      parallels.customize ["set", :id, "--memsize", server_memory]

  end

  # If using VMWare Fusion
  config.vm.provider :vmware_fusion do |vb|

    # Set server memory
    vb.vmx["memsize"] = server_memory

  end

  ####
  # Base Items
  ##########

  # echo "StrictHostKeyChecking no" >> ~/.ssh/config

  # Provision Base Packages
  config.vm.provision "shell", path: "https://raw.github.com/#{github_username}/#{github_repo}/#{github_branch}/scripts/base.sh"

  # Provision PHP
  config.vm.provision "shell", path: "https://raw.github.com/#{github_username}/#{github_repo}/#{github_branch}/scripts/php.sh", args: [php_version, server_timezone]

  # Enable MSSQL for PHP
  config.vm.provision "shell", path: "https://raw.github.com/#{github_username}/#{github_repo}/#{github_branch}/scripts/mssql.sh"

  # Enable Firebird for PHP
  config.vm.provision "shell", inline: "apt-get install -y php5-interbase"

  # Provision Oh-My-Zsh
  config.vm.provision "shell", path: "https://raw.github.com/#{github_username}/#{github_repo}/#{github_branch}/scripts/zsh.sh"

  # Provision Vim
  # config.vm.provision "shell", path: "https://raw.github.com/#{github_username}/#{github_repo}/#{github_branch}/scripts/vim.sh"


  ####
  # Web Servers
  ##########

  # Provision Apache Base
  # config.vm.provision "shell", path: "https://raw.github.com/#{github_username}/#{github_repo}/#{github_branch}/scripts/apache.sh", args: [server_ip, public_folder]

  # Provision HHVM
  # Install HHVM & HHVM-FastCGI
  # config.vm.provision "shell", path: "https://raw.github.com/#{github_username}/#{github_repo}/#{github_branch}/scripts/hhvm.sh"

  # Provision Nginx Base
  # config.vm.provision "shell", path: "https://raw.github.com/#{github_username}/#{github_repo}/#{github_branch}/scripts/nginx.sh", args: [server_ip, public_folder]


  ####
  # Databases
  ##########

  # Provision MySQL
  # config.vm.provision "shell", path: "https://raw.github.com/#{github_username}/#{github_repo}/#{github_branch}/scripts/mysql.sh", args: [mysql_root_password, mysql_version, mysql_enable_remote]

  # Provision PostgreSQL
  config.vm.provision "shell", path: "https://raw.github.com/#{github_username}/#{github_repo}/#{github_branch}/scripts/pgsql.sh", args: pgsql_root_password

  # Provision SQLite
  # config.vm.provision "shell", path: "https://raw.github.com/#{github_username}/#{github_repo}/#{github_branch}/scripts/sqlite.sh"

  # Provision Couchbase
  # config.vm.provision "shell", path: "https://raw.github.com/#{github_username}/#{github_repo}/#{github_branch}/scripts/couchbase.sh"

  # Provision CouchDB
  # config.vm.provision "shell", path: "https://raw.github.com/#{github_username}/#{github_repo}/#{github_branch}/scripts/couchdb.sh"

  # Provision MongoDB
  # config.vm.provision "shell", path: "https://raw.github.com/#{github_username}/#{github_repo}/#{github_branch}/scripts/mongodb.sh"

  # Provision MariaDB
  config.vm.provision "shell", path: "https://raw.github.com/#{github_username}/#{github_repo}/#{github_branch}/scripts/mariadb.sh", args: [mariadb_root_password, mariadb_version]

  # Provision Firebird
  config.vm.provision "shell", path: "https://raw.github.com/#{github_username}/#{github_repo}/#{github_branch}/scripts/firebird.sh", args: [firebird_sysdba_password]

  ####
  # Search Servers
  ##########

  # Install Elasticsearch
  # config.vm.provision "shell", path: "https://raw.github.com/#{github_username}/#{github_repo}/#{github_branch}/scripts/elasticsearch.sh"

  # Install SphinxSearch
  # config.vm.provision "shell", path: "https://raw.github.com/#{github_username}/#{github_repo}/#{github_branch}/scripts/sphinxsearch.sh"

  ####
  # Search Server Administration (web-based)
  ##########

  # Install ElasticHQ
  # Admin for: Elasticsearch
  # Works on: Apache2, Nginx
  # config.vm.provision "shell", path: "https://raw.github.com/#{github_username}/#{github_repo}/#{github_branch}/scripts/elastichq.sh"


  ####
  # In-Memory Stores
  ##########

  # Install Memcached
  # config.vm.provision "shell", path: "https://raw.github.com/#{github_username}/#{github_repo}/#{github_branch}/scripts/memcached.sh"

  # Provision Redis (without journaling and persistence)
  # config.vm.provision "shell", path: "https://raw.github.com/#{github_username}/#{github_repo}/#{github_branch}/scripts/redis.sh"

  # Provision Redis (with journaling and persistence)
  # config.vm.provision "shell", path: "https://raw.github.com/#{github_username}/#{github_repo}/#{github_branch}/scripts/redis.sh", args: "persistent"
  # NOTE: It is safe to run this to add persistence even if originally provisioned without persistence


  ####
  # Utility (queue)
  ##########

  # Install Beanstalkd
  # config.vm.provision "shell", path: "https://raw.github.com/#{github_username}/#{github_repo}/#{github_branch}/scripts/beanstalkd.sh"

  # Install Heroku Toolbelt
  # config.vm.provision "shell", path: "https://toolbelt.heroku.com/install-ubuntu.sh"

  # Install Supervisord
  # config.vm.provision "shell", path: "https://raw.github.com/#{github_username}/#{github_repo}/#{github_branch}/scripts/supervisord.sh"

  ####
  # Additional Languages
  ##########

  # Install Nodejs
  # config.vm.provision "shell", path: "https://raw.github.com/#{github_username}/#{github_repo}/#{github_branch}/scripts/nodejs.sh", privileged: false, args: nodejs_packages.unshift(nodejs_version)

  # Install Ruby Version Manager (RVM)
  # config.vm.provision "shell", path: "https://raw.github.com/#{github_username}/#{github_repo}/#{github_branch}/scripts/rvm.sh", privileged: false, args: ruby_gems.unshift(ruby_version)

  ####
  # Frameworks and Tooling
  ##########

  # Provision Composer
  config.vm.provision "shell", path: "https://raw.github.com/#{github_username}/#{github_repo}/#{github_branch}/scripts/composer.sh", privileged: false, args: composer_packages.join(" ")

  # Install Screen
  config.vm.provision "shell", path: "https://raw.github.com/#{github_username}/#{github_repo}/#{github_branch}/scripts/screen.sh"

  # Install Mailcatcher
  config.vm.provision "shell", path: "https://raw.github.com/#{github_username}/#{github_repo}/#{github_branch}/scripts/mailcatcher.sh"

end
