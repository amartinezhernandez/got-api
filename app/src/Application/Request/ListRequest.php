<?php


namespace App\Application\Request;


class ListRequest
{
    private int $page;
    private int $offset;
    private int $limit;
    private ?string $search;

    public function __construct(
        ?int $page,
        int $limit,
        ?string $search = null
    )
    {
        $this->setPage($page);
        $this->limit = $limit;
        $offset = ($this->page() - 1) * $this->limit();
        $this->offset = $offset;
        $this->search = $search;
    }

    public function setPage(?int $page): void
    {
        $this->page = $page && $page > 0 ? $page : 1;
    }

    public function page(): int
    {
        return $this->page;
    }

    public function offset(): int
    {
        return $this->offset;
    }

    public function limit(): int
    {
        return $this->limit;
    }

    public function search(): ?string
    {
        return $this->search;
    }
}
