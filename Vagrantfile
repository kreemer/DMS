Vagrant.configure("2") do |config|
    # v2 configs...
    config.vm.box = "precise32"
    config.vm.box_url = "http://files.vagrantup.com/precise32.box"
    config.vm.network :private_network, ip: "192.168.31.5"
    config.vm.network :forwarded_port, guest: 80, host: 4567

    config.vm.provider :virtualbox do |vb|
        vb.gui = true
        # vb.customize ["modifyvm", :id, "--cpuexecutioncap", "50"]
        # vb.customize ["modifyvm", :id, "--memory", "256"]
    end

    config.vm.provision :puppet do |puppet|
        puppet.manifests_path = "manifests"
        puppet.manifest_file = "app.pp"
    end

end