<?php

namespace Chuva\Php\WebScrapping\Entity;

/**
 * Paper Author personal information.
 */
class Person {

  public string $name;

  public string $institution;

  /**
   * Builder.
   */
  public function __construct($name, $institution) {
    $this->name = $name;
    $this->institution = $institution;
  }

}
