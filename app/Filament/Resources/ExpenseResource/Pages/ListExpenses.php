<?php

namespace App\Filament\Resources\ExpenseResource\Pages;

use App\Models\Type;
use Filament\Actions;
use App\Models\Expense;
use App\Enums\TypeKeyEnum;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ExpenseResource;

class ListExpenses extends ListRecords
{
    protected static string $resource = ExpenseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        $tabs = [];

        $tabs['all'] = Tab::make(trans('models.common.all'))
            ->badge(Expense::count());

        foreach (Type::where('key', TypeKeyEnum::EXPENSE->value)->get() as $type) {
            $tabs[$type?->name] = Tab::make($type?->name)
                ->modifyQueryUsing(fn (Builder $query) => $query->where('type_id', $type?->id))
                ->badge(Expense::where('type_id', $type?->id)->count());
        }

        return $tabs;
    }
}
