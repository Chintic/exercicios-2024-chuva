<?php

namespace Chuva\Php\WebScrapping;

use Chuva\Php\WebScrapping\Entity\Paper;
use Chuva\Php\WebScrapping\Entity\Person;

/**
 * Does the scrapping of a webpage.
 */
class Scrapper {

  private $queryPaperId = '//div[@class="volume-info"]';
  private $queryPaperTitle = './/h4[@class="my-xs paper-title"]';
  private $queryPaperType = '//div[@class="tags mr-sm"]';
  private $queryPerson = '//div[@class="authors"]';

  /**
   * Loads paper information from the HTML and returns the array with the data.
   */
  public function scrap(\DOMDocument $dom): array {
    
    $xPath = new \DOMXPath($dom);

    $domPaperIdList = $xPath->query($this->queryPaperId);
    $domPaperTitleList = $xPath->query($this->queryPaperTitle);
    $domPaperTypeList = $xPath->query($this->queryPaperType);
    $domPersonList = $xPath->query($this->queryPerson);

    return [
      new Paper(
        $domPaperIdList[0]->textContent,
        $domPaperTitleList[0]->textContent,
        $domPaperTypeList[0]->textContent,
        [
          new Person('Katalin Karikó', 'Szeged University'),
          new Person('Drew Weissman', 'University of Pennsylvania'),
        ]
      ),
    ];
  }

}
