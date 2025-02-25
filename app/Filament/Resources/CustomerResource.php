<?php
namespace App\Filament\Resources;

use App\Enums\TypeKeyEnum;
use App\Filament\Resources\CustomerResource\Pages;
use App\Filament\Resources\CustomerResource\RelationManagers\TransactionsRelationManager;
use App\Models\Customer;
use App\Models\Type;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Pages\SubNavigationPosition;
use Filament\Resources\Pages\Page;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\ActionSize;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?int $navigationSort = 1;

    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label(__('models.customers.fields.name'))
                            ->required()
                            ->maxLength(255),

                        Forms\Components\Select::make('type_id')
                            ->label(__('models.customers.fields.type'))
                            ->options(Type::where('key', TypeKeyEnum::CUSTOMER->value)->pluck('name', 'id'))
                            ->required()
                            ->searchable()
                            ->preload(),

                        Forms\Components\Hidden::make('user_id')
                            ->default(auth()->user()->id),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('models.customers.fields.name'))
                    ->searchable(),

                Tables\Columns\TextColumn::make('type.name')
                    ->label(__('models.customers.fields.type'))
                    ->badge(),

                Tables\Columns\TextColumn::make('total_transaction')
                    ->label(__('models.customers.fields.total_transaction'))
                    ->numeric()
                    ->suffix(' x')
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('total_products_purchased')
                    ->label(__('models.customers.fields.total_products_purchased'))
                    ->numeric()
                    ->suffix(' item')
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('total_buy')
                    ->label(__('models.customers.fields.total_buy'))
                    ->formatStateUsing(fn(string $state): string => __("Rp. " . number_format($state, 0, ',', '.')))
                    ->weight(FontWeight::SemiBold)
                    ->sortable(query: function (Builder $query, string $direction): Builder {
                        return $query->select(
                            "*",
                            DB::raw('(SELECT SUM(subtotal_after_discount) FROM transactions WHERE transactions.customer_id = customers.id) as total_buy')
                        )
                            ->orderBy('total_buy', $direction);
                    }),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label(__('models.customers.links.view'))
                    ->icon('heroicon-o-shopping-cart')
                    ->button()
                    ->color(Color::Rose),
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ])
                    ->label(__('models.common.actions'))
                    ->button()
                    ->color(Color::Gray)
                    ->size(ActionSize::Small),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            TransactionsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
            'view'   => Pages\ViewCustomer::route('/{record}'),
            'edit'   => Pages\EditCustomer::route('/{record}/edit'),
        ];
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Data ' . __('models.customers.title'))
                    ->columns(5)
                    ->collapsible()
                    ->schema([
                        Infolists\Components\TextEntry::make('name')
                            ->label(__('models.customers.fields.name')),
                        Infolists\Components\TextEntry::make('type.name')
                            ->label(__('models.customers.fields.type'))
                            ->badge(),
                        Infolists\Components\TextEntry::make('total_transaction')
                            ->label(__('models.customers.fields.total_transaction'))
                            ->suffix(' x'),
                        Infolists\Components\TextEntry::make('total_products_purchased')
                            ->label(__('models.customers.fields.total_products_purchased'))
                            ->suffix(' item'),
                        Infolists\Components\TextEntry::make('total_buy')
                            ->label(__('models.customers.fields.total_buy'))
                            ->formatStateUsing(fn(string $state): string => __("Rp. " . number_format($state, 0, ',', '.'))),
                    ]),

            ]);
    }

    public static function getRecordSubNavigation(Page $page): array
    {
        return $page->generateNavigationItems([
            Pages\ViewCustomer::class,
            Pages\EditCustomer::class,
        ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return static::getModel()::query()->latest();
    }

    public static function getLabel(): string
    {
        return __('models.customers.title');
    }

    public static function canAccess(): bool
    {
        return auth()->user()->role->isUser() || auth()->user()->role->isFree();
    }
}
