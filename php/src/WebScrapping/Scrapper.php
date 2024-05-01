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
    $domAuthorsList = $xPath->query($this->queryPerson);

    $papers = [];
    for ($i = 0; $i < $domPaperIdList->length; $i++) {
      $paperId = $domPaperIdList[$i]->textContent;
      $paperTitle = $domPaperTitleList[$i]->textContent;
      $paperType = $domPaperTypeList[$i]->textContent;

      $paperAuthors = [];
      $domAuthors = $domAuthorsList[$i]->getElementsByTagName('span');
      foreach ($domAuthors as $domAuthor) {
        $authorName = $domAuthor->textContent;
        $institution = $domAuthor->getAttribute('title');
        $paperAuthors[] = new Person($authorName, $institution);
      }

      $papers[] = new Paper($paperId, $paperTitle, $paperType, $paperAuthors);
    }

    return $papers;
  }

}
