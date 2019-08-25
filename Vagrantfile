
Vagrant.configure("2") do |config|
  config.vm.box = "debian/stretch64"

  config.vm.provider "virtualbox" do |v|
    v.memory = 4096
    v.cpus = 2
  end

  config.vm.network "private_network", type: "dhcp"
  config.vm.network "forwarded_port", guest: 80, host_ip: "127.0.0.1", host: 8080

  config.vm.provider "virtualbox"

  local_folder = "/vagrant"

  if(Vagrant::Util::Platform.windows?)
    config.winnfsd.uid = Process.uid
    config.winnfsd.gid = Process.gid
  else
    config.nfs.map_uid = Process.uid
    config.nfs.map_gid = Process.gid
  end

  config.vm.synced_folder ".", local_folder, mount_options: ["nolock"], type: "nfs"

end
