<?php

namespace App\Filament\Resources\ExpenseResource\Pages;

use Filament\Actions;
use App\Models\Expense;
use App\Enums\ExpenseTypeEnum;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\ExpenseResource;
use Illuminate\Database\Eloquent\Builder;

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

        foreach (ExpenseTypeEnum::cases() as $type) {
            $tabs[$type->value] = Tab::make($type->value)
                ->modifyQueryUsing(fn (Builder $query) => $query->where('type', $type->value))
                ->badge(Expense::where('type', $type->value)->count())
                ->badgeColor($type->getColor())
                ->badgeIcon($type->getIcon());
        }

        return $tabs;
    }
}
