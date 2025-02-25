<?php

require_once dirname(__DIR__) . '/config/Config.php';
require_once dirname(__DIR__) . '/utils/Utilities.php';

class Category {
  // Properties
  private Config $config;
  public string $title;
  public string $slug;
  public string $canonical;

  // Constructor
  public function __construct(string $title) {
    $this->config = new Config();
    $this->title = $title;
    $this->slug = Utilities::convertTitleToSlug($title);
    $this->canonical = "{$this->config->SITE_ADDRESS}/category/{$this->slug}.html";
  }

  public function toListItemHTML() {
    return "<li class=\"category-list-item\">{$this->toLinkHTML()}</li>";
  }

  public function toMenuItemHTML() {
    return "<li class=\"menu-list-item\">{$this->toMenuLinkHTML()}</li>";
  }

  public function toLinkHTML() {
    return "<a href=\"{$this->config->SITE_URL_ROOT}/category/{$this->slug}.html\">$this->title</a>";
  }

  // In menu display only first word of the title
  private function toMenuLinkHTML() {
    $firstWord = explode(' ', trim($this->title))[0];
    return "<a href=\"{$this->config->SITE_URL_ROOT}/category/{$this->slug}.html\">$firstWord</a>";
  }

  public function toCommaSeparatedTitle() {
    $words = explode(' ', trim($this->title));
    return implode(', ', $words);
  }

  public function toSiteMapItemXML($xml) {
    $url = $xml->addChild('url');
    $url->addChild('loc', htmlspecialchars("$this->canonical"));
    $url->addChild('lastmod', date('Y-m-d'));
    $url->addChild('changefreq', 'weekly');
    $url->addChild('priority', '0.8');
  }
}
