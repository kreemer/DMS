
class package_phpunit
{
  exec
  {
    'pear.autodiscover':
      path => '/bin:/usr/bin:/usr/sbin',
      command => 'pear config-set auto_discover 1'
  }

  exec
  {
    'phpunit.install':
      creates => '/usr/bin/phpunit',
      path => '/bin:/usr/bin:/usr/sbin',
      command => 'pear install pear.phpunit.de/PHPUnit --alldeps',
      require => Exec['pear.autodiscover']
  }

}
