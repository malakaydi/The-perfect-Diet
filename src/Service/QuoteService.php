<?php


namespace App\Service;

class QuoteService
{
    private $quotes = [
        '"The only way to keep your health is to eat what you don t want, drink what you don t like, and do what you d rather not."',
        '"Your diet is a bank account. Good food choices are good investments."',
        '"Pasta doesn t make you fat. How much pasta you eat makes you fat."',
        '"If you keep good food in your fridge, you will eat good food."',
        '"It takes five minutes to consume 500 calories. It takes two hours to burn them off."',
        '"One must eat to live, not live to eat."',
        '"Don t dig your grave with your own knife and fork."'
    ];

    public function getRandomQuote(): string
    {
        $randomIndex = array_rand($this->quotes);

        return $this->quotes[$randomIndex];
    }
}