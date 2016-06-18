<?php
namespace Wish\Presenters;

use Wish\Wish;

class WishPresenter
{
    protected $wish;
    
    public function __construct(Wish $wish)
    {
        $this->wish = $wish;
    }
    
    public function description()
    {

        return $this->wrapUrls(nl2br($this->wish->description));
    }

    protected function wrapUrls($text = "")
    {
        $pattern = "/(http|https)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
        return preg_replace_callback($pattern, function ($matches) {
            $link = $matches[0];
            return "<a href='$link' target='_blank' rel='noopener noreferrer' title='$link'>$link</a>";
        }, $text);
    }
}