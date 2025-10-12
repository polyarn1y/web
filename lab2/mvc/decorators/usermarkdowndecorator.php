<?php
namespace MVC\Decorators;

class UserMarkdownDecorator extends DecoratorFactory
{
    public $user;

    public function __construct(\MVC\Models\User $user)
    {
        $this->user = $user;
    }

    public function title(): string
    {
        return "{$this->user->first_name} {$this->user->last_name}";
    }

    public function body(): string
    {
        return "- **{$this->user->first_name} {$this->user->last_name}** ({$this->user->email})";
    }

    public function items(): string
    {
        return "- {$this->user->first_name} {$this->user->last_name} ({$this->user->email})";
    }
}
