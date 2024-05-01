<?php

namespace Chuva\Php\WebScrapping\Entity;

/**
 * Paper Author personal information.
 */
class Person {

  public string $name;

  public string $institution;

  public function getName() {
    return $this->name;
  }

  public function getInstitution() {
    return $this->institution;
  }

  /**
   * Builder.
   */
  public function __construct($name, $institution) {
    $this->name = $name;
    $this->institution = $institution;
  }

}
