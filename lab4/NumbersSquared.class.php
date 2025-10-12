<?php
/**
 * NumbersSquared — итератор, который перебирает числа от start до end
 * и возвращает их квадраты.
 */
class NumbersSquared implements Iterator
{
    /** @var int */
    private $start;

    /** @var int */
    private $end;

    /** @var int */
    private $current;

    public function __construct(int $start, int $end)
    {
        $this->start = $start;
        $this->end = $end;
        $this->current = $start;
    }

    public function current()
    {
        return $this->current * $this->current;
    }

    public function key()
    {
        return $this->current;
    }

    public function next(): void
    {
        $this->current++;
    }

    public function rewind(): void
    {
        $this->current = $this->start;
    }

    public function valid(): bool
    {
        return $this->current <= $this->end;
    }
}

$obj = new NumbersSquared(3, 7);

foreach ($obj as $num => $square) {
    echo "Квадрат числа $num = $square<br>";
}
