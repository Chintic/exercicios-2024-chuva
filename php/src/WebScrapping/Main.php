<?php

namespace Chuva\Php\WebScrapping;

use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use Box\Spout\Common\Entity\Row;
use Box\Spout\Writer\Common\Creator\Style\StyleBuilder;

/**
 * Runner for the Webscrapping exercice.
 */
class Main {

  /**
   * Main runner, instantiates a Scrapper and runs.
   */
  public static function run(): void {

    libxml_use_internal_errors(true);
    $dom = new \DOMDocument('1.0', 'utf-8');
    $dom->loadHTMLFile(__DIR__ . '/../../assets/origin.html');

    $papers = (new Scrapper())->scrap($dom);

    // Write your logic to save the output file bellow.
    
    $writer = WriterEntityFactory::createXLSXWriter();  
      
    $filePath = __DIR__ . '/../../assets/model.xlsx';
    $writer->openToFile($filePath);

    $headerStyle = (new StyleBuilder())
      ->setFontBold()
      ->setFontName('Arial')      
      ->setFontSize(10)
      ->build();

    $contentStyle = (new StyleBuilder())
      ->setFontName('Arial')
      ->setFontSize(10)
      ->build();
    
    $header = [
      WriterEntityFactory::createCell('ID'),
      WriterEntityFactory::createCell('Title'),
      WriterEntityFactory::createCell('Type')
    ];
    
    $biggestAuthorNumber = 0;

    foreach ($papers as $paper) {
      $authorsCount = count($paper->getAuthors());
      if ($authorsCount > $biggestAuthorNumber) {
        $biggestAuthorNumber = $authorsCount;
      }
    }

    for ($i = 1; $i <= $biggestAuthorNumber; $i++) {
      $header[] = WriterEntityFactory::createCell("Author $i");
      $header[] = WriterEntityFactory::createCell("Author $i Institution");
    }
    
    $headerRow = WriterEntityFactory::createRow($header, $headerStyle);
    $writer->addRow($headerRow);

    $paperRows = [];
    for ($i = 0; $i < count($papers); $i++) {
      $paper = $papers[$i];
      $rowData = [
        $paper->getId(),
        $paper->getTitle(),
        $paper->getType()
      ];

      $authors = $paper->getAuthors();
      for ($j = 0; $j < count($authors); $j++) {
        $author = $authors[$j];
        $rowData[] = $author->getName();
        $rowData[] = $author->getInstitution();
      }

      $paperRows[] = WriterEntityFactory::createRowFromArray($rowData, $contentStyle);
    }
    $writer->addRows($paperRows);

    $writer->close();
  }

}
