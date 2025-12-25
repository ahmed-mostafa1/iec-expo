<?php

namespace App\Livewire\Admin;

use App\Models\SponsorRegistration;
use Livewire\Component;
use Livewire\WithPagination;

class SponsorRegistrationsTable extends Component
{
    use WithPagination;

    public string $search = '';
    public string $status = '';
    public string $dateFrom = '';
    public string $dateTo = '';

    protected $queryString = [
        'search'   => ['except' => ''],
        'status'   => ['except' => ''],
        'dateFrom' => ['except' => ''],
        'dateTo'   => ['except' => ''],
        'page'     => ['except' => 1],
    ];

    public function updating($name)
    {
        if (in_array($name, ['search', 'status', 'dateFrom', 'dateTo'])) {
            $this->resetPage();
        }
    }

    public function render()
    {
        $query = SponsorRegistration::query();

        if ($this->status !== '') {
            $query->where('status', $this->status);
        }

        if ($this->search !== '') {
            $search = $this->search;
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('organization', 'like', "%{$search}%")
                    ->orWhere('location_selection', 'like', "%{$search}%")
                    ->orWhere('vat_number', 'like', "%{$search}%")
                    ->orWhere('cr_number', 'like', "%{$search}%");
            });
        }

        if ($this->dateFrom) {
            $query->whereDate('created_at', '>=', $this->dateFrom);
        }

        if ($this->dateTo) {
            $query->whereDate('created_at', '<=', $this->dateTo);
        }

        $registrations = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('livewire.admin.sponsor-registrations-table', [
            'registrations' => $registrations,
        ]);
    }

    public function export()
    {
        // redirect to export route with current filters as query params
        return redirect()->route('admin.sponsors.export', [
            'search'   => $this->search,
            'status'   => $this->status,
            'dateFrom' => $this->dateFrom,
            'dateTo'   => $this->dateTo,
        ]);
    }
}
