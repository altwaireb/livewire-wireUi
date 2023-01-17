<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Livewire\WithPagination;

trait WithSorting
{
    use WithPagination;

    public string|null $search = null;
    public string $sortBy = 'id';
    public string $sortDirection = 'asc';
    public int $perPage = 10;

    public function queryStringWithSorting()
    {
        return [
            'search' => ['except' => '', 'as' => 's'],
            'sortBy' => ['except' => 'id', 'as' => 'sort'],
            'sortDirection' => ['except' => 'asc', 'as' => 'dir'],
            'perPage' => ['except' => 10, 'as' => 'p']
        ];
    }

    public function sortBy($field): void
    {
        $this->sortDirection = $this->sortBy === $field
            ? $this->reverseSort()
            : 'asc';

        $this->sortBy = $field;
    }

    public function reverseSort(): string
    {
        return $this->sortDirection === 'asc'
            ? 'desc'
            : 'asc';
    }

    public function orderAndPaginate(Builder $query)
    {
        if (!empty($this->search)) {
            $query = $query->search(trim($this->search));
        }

        return $query->orderBy($this->sortBy, $this->sortDirection)
            ->paginate($this->perPage);
    }

    public function updatingPerPage(): void
    {
        $this->resetPage();
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function resetSearch(): void
    {
        $this->reset('search');
    }

}