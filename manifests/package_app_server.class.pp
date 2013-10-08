
class package_app_server
{

  package
  {
    'lftp':
      ensure => present
  }

  package
  {
    'ant':
      ensure => present
  }

  package
  {
    'sendmail':
      ensure  => present
  }

  package
  {
    'mysql-server':
      ensure  => present
  }

  package
  {
    'mysql-client':
      ensure  => present
  }

  package
  {
    'apache2':
      ensure  => present,
      require => Package['mysql-server']
  }

  package
  {
    'php5':
      ensure  => present,
      require => Package['apache2']
  }

  package
  {
    'php5-intl':
      ensure  => present,
      require => Package['php5']
  }

  package
  {
    'php-apc':
      ensure  => present,
      require => Package['php5']
  }

  package
  {
    'php5-xdebug':
      ensure  => present,
      require => Package['php5']
  }

  package
  {
    'php5-curl':
      ensure  => present,
      require => Package['php5']
  }

  package
  {
    'php5-sqlite':
      ensure  => present,
      require => Package['php5']
  }

  package
  {
    'phpmyadmin':
      ensure  => present,
      require => Package['php5']
  }

  package
  {
    'php5-cli':
      ensure  => present,
      require => Package['php5']
  }

  package
  {
    'php-pear':
      ensure  => present,
      require => Package['php5-cli']
  }

  package
  {
    'wget':
      ensure => present
  }

  file
  {
    'pear.tmpdirfix.prepare':
      ensure  => directory,
      path    => '/tmp/pear',
      require => Package['php-pear']
  }

  file
  {
    'pear.tmpdirfix':
      ensure  => directory,
      path    => '/tmp/pear/cache',
      mode    => 777,
      require => File['pear.tmpdirfix.prepare']
  }

  exec
  {
    'pear.upgrade.pear':
      path => '/bin:/usr/bin:/usr/sbin',
      command => 'pear upgrade PEAR',
      require => File['pear.tmpdirfix']
  }

    exec { 'download_composer':
      path => '/bin:/usr/bin:/usr/sbin',

        command     => 'wget http://getcomposer.org/composer.phar -O /tmp/composer.phar',
        require     => [
            Package['wget']
        ],
        creates     => "/tmp/composer.phar"
    }

  # check if directory exists
  file { "/usr/local/bin":
    ensure      => directory
  }

    # move file to target_dir
    file { "/usr/local/bin/composer":
      ensure      => present,
      source      => "/tmp/composer.phar",
      require     => [ Exec['download_composer'], File["/usr/local/bin"], ],
      group       => 'users',
      mode        => '0755'
    }

    # run composer self-update
    exec { 'update_composer':
      command     => "/usr/local/bin/composer self-update",
      require     => [
        File["/usr/local/bin/composer"],
        Package["php5-cli"]
      ]
    }

    package
    {
        'xvfb':
            ensure => present
    }

    package
    {
        'firefox':
            ensure => present
    }

    exec { 'download_selenium':
        command     => '/usr/bin/wget http://selenium.googlecode.com/files/selenium-server-standalone-2.32.0.jar -O /usr/bin/selenium-server-standalone.jar',
        creates     => '/usr/bin/selenium-server-standalone.jar'
    }

    file { "/usr/bin/selenium-start":
        ensure  => present,
        path    => '/usr/bin/selenium-start',
        source  => '/vagrant/resources/app/usr/bin/selenium-start',
        mode    => '0755'
    }

    file { "/usr/bin/selenium-stop":
        ensure  => present,
        path    => '/usr/bin/selenium-stop',
        source  => '/vagrant/resources/app/usr/bin/selenium-stop',
        mode    => '0755'
    }



  # Change user / group
  exec { "Add-ppa" :
      command => "/usr/bin/add-apt-repository ppa:chris-lea/node.js -y",
      creates  => "/etc/apt/sources.list.d/chris-lea-node_js-precise.list",
      notify => Exec['Ppa-update']
  }

  exec { "Ppa-update" :
    command => "/usr/bin/apt-get update"
  }

  package
  {
    'nodejs':
        ensure  => present,
        require => Exec['Add-ppa']
  }

  exec { "Install-npm" :
    command => "/usr/bin/curl https://npmjs.org/install.sh | sh",
    require => [ Package["nodejs"] , Package["curl"] ],
    creates => "/usr/bin/npm"
  }

  package
  {
    'curl':
        ensure  => present
  }

  exec { "Install-Less" :
    command => "/usr/bin/npm install less -g",
    require => Exec["Install-npm"],
    creates => "/usr/lib/node_modules/less/bin/lessc"
  }
}
