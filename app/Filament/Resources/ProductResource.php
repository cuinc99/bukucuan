<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Type;
use Filament\Tables;
use App\Models\Product;
use Filament\Infolists;
use Filament\Forms\Form;
use App\Enums\TypeKeyEnum;
use Filament\Tables\Table;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\ActionSize;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ProductResource\Pages;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-gift';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label(__('models.products.fields.name'))
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),

                        Forms\Components\Select::make('type_id')
                            ->label(__('models.products.fields.category'))
                            ->options(Type::where('key', TypeKeyEnum::PRODUCT->value)->pluck('name', 'id'))
                            ->required()
                            ->searchable()
                            ->preload()
                            ->createOptionForm([
                                Forms\Components\TextInput::make('name')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\Hidden::make('key')
                                    ->default(TypeKeyEnum::PRODUCT->value),
                            ])
                            ->createOptionUsing(function (array $data): int {
                                return auth()->user()->types()->create($data)->getKey();
                            }),

                        Forms\Components\TextInput::make('purchase_price')
                            ->label(__('models.products.fields.purchase_price'))
                            ->required()
                            ->numeric(),

                        Forms\Components\TextInput::make('selling_price')
                            ->label(__('models.products.fields.selling_price'))
                            ->required()
                            ->numeric(),

                        Forms\Components\Textarea::make('description')
                            ->label(__('models.products.fields.description'))
                            ->columnSpanFull(),

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
                    ->label(__('models.products.fields.name'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('purchase_price')
                    ->label(__('models.products.fields.purchase_price'))
                    ->formatStateUsing(fn(string $state): string => __("Rp. " . number_format($state, 0, ',', '.')))
                    ->sortable(),
                Tables\Columns\TextColumn::make('selling_price')
                    ->label(__('models.products.fields.selling_price'))
                    ->formatStateUsing(fn(string $state): string => __("Rp. " . number_format($state, 0, ',', '.')))
                    ->sortable(),
                Tables\Columns\TextColumn::make('sold')
                    ->label(__('models.products.fields.sold'))
                    ->suffix(' item')
                    ->alignCenter(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageProducts::route('/'),
        ];
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make()
                    ->schema([
                        Infolists\Components\TextEntry::make('name')
                            ->label(__('models.products.fields.name')),
                        Infolists\Components\TextEntry::make('purchase_price')
                            ->label(__('models.products.fields.purchase_price'))
                            ->formatStateUsing(fn(string $state): string => __("Rp. " . number_format($state, 0, ',', '.'))),
                        Infolists\Components\TextEntry::make('selling_price')
                            ->label(__('models.products.fields.selling_price'))
                            ->formatStateUsing(fn(string $state): string => __("Rp. " . number_format($state, 0, ',', '.'))),
                        Infolists\Components\TextEntry::make('sold')
                            ->label(__('models.products.fields.sold'))
                            ->suffix(' item'),
                        Infolists\Components\TextEntry::make('description')
                            ->label(__('models.products.fields.description')),
                    ]),

            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return static::getModel()::query()->latest();
    }

    public static function getLabel(): string
    {
        return __('models.products.title');
    }

    public static function canAccess(): bool
    {
        return auth()->user()->role->isUser() || auth()->user()->role->isFree();
    }
}
