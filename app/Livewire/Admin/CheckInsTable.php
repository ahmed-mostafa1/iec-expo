<?php

namespace App\Livewire\Admin;

use App\Models\CheckIn;
use App\Models\Employee;
use App\Support\RegistrationTypes;
use Livewire\Component;
use Livewire\WithPagination;

class CheckInsTable extends Component
{
    use WithPagination;

    public string $search = '';

    public string $type = '';

    public string $employeeId = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'type' => ['except' => ''],
        'employeeId' => ['except' => ''],
        'page' => ['except' => 1],
    ];

    public function updating($name)
    {
        if (in_array($name, ['search', 'type', 'employeeId'])) {
            $this->resetPage();
        }
    }

    public function render()
    {
        $query = CheckIn::query()->with(['employee', 'registrant']);

        if ($this->type !== '') {
            $query->where('registrant_type', $this->type);
        }

        if ($this->employeeId !== '') {
            $query->where('employee_id', $this->employeeId);
        }

        if ($this->search !== '') {
            $search = $this->search;
            $query->where(function ($q) use ($search) {
                $q->whereHasMorph('registrant', array_keys(RegistrationTypes::TYPE_MODELS), function ($q) use ($search) {
                    $q->where('full_name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                })->orWhereHas('employee', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });
            });
        }

        $checkIns = $query->orderBy('scanned_at', 'desc')->paginate(15);
        $employees = Employee::orderBy('name')->get();

        return view('livewire.admin.check-ins-table', compact('checkIns', 'employees'));
    }

    public function export()
    {
        return redirect()->route('admin.check-ins.export', [
            'search' => $this->search,
            'type' => $this->type,
            'employeeId' => $this->employeeId,
        ]);
    }
}
