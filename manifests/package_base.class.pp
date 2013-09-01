
class package_base
{

  exec
  {
    'init':
      command => 'apt-get update',
      path    => '/usr/bin/'
  }

  package
  {
    'htop':
      ensure  => present,
      require => Exec['init']
  }

  file
  {
    'vagrant.bash_profile':
      path    => '/home/vagrant/.bash_profile',
      ensure  => present,
      source  => '/vagrant/resources/app/home/vagrant/.bash_profile'
  }

  file
  {
    'vagrant.bashrc':
      path    => '/home/vagrant/.bashrc',
      ensure  => present,
      source  => '/vagrant/resources/app/home/vagrant/.bashrc'
  }

  file
  {
    'vagrant.symfony2init':
      path    => '/home/vagrant/symfony2init.sh',
      ensure  => present,
      source  => '/vagrant/resources/app/home/vagrant/symfony2init.sh',
      mode    => 0777
  }
}
