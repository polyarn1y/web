<?php
namespace MVC\Views;

class MarkdownView extends ViewFactory
{
    protected array $replacements;

    public function __construct(object $decorator)
    {
        $this->replacements = [
            '{{{body}}}' => $decorator->body(),
        ];
    }

    public function render(): string
    {
        return $this->replacements['{{{body}}}'];
    }
}
