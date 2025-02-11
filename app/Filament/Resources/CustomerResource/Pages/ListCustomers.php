<?php

namespace App\Filament\Resources\CustomerResource\Pages;

use App\Models\Type;
use Filament\Actions;
use App\Models\Customer;
use App\Enums\TypeKeyEnum;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\CustomerResource;

class ListCustomers extends ListRecords
{
    protected static string $resource = CustomerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->disabled(fn (): bool => Customer::isOutOfQuota()),
        ];
    }

    public function getTabs(): array
    {
        $tabs = [];

        $tabs['all'] = Tab::make(trans('models.common.all'))
            ->badge(Customer::count());

        foreach (Type::where('key', TypeKeyEnum::CUSTOMER->value)->get() as $type) {
            $tabs[$type->value] = Tab::make($type->name)
                ->modifyQueryUsing(fn (Builder $query) => $query->where('type_id', $type->id));
                // ->badge(Customer::where('type', $type->id)->count())
                // ->badgeColor($type->getColor())
                // ->badgeIcon($type->getIcon());
        }

        return $tabs;
    }
}
