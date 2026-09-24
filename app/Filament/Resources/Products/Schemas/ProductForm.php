<?php

namespace App\Filament\Resources\Products\Schemas;

use App\Enums\Product\ProductStatusEnum;
use App\Models\Category;
use App\Models\Tag;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Product Details')->schema([
                    Select::make('category_id')
                        ->label('Category')
                        ->options(Category::pluck('name', 'id'))
                        ->searchable()
                        ->required(),
                    TextInput::make('name')
                        ->required()
                        ->maxLength(255)
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),
                    TextInput::make('slug')
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->maxLength(255),
                    Textarea::make('description')
                        ->rows(3),
                ]),
                Section::make('Pricing & Stock')->schema([
                    TextInput::make('price')
                        ->numeric()
                        ->prefix('$')
                        ->required()
                        ->minValue(0),
                    TextInput::make('stock')
                        ->numeric()
                        ->default(0)
                        ->minValue(0),
                    Select::make('status')
                        ->options(collect(ProductStatusEnum::cases())->mapWithKeys(
                            fn ($case) => [$case->value => $case->label()]
                        ))
                        ->required()
                        ->default(ProductStatusEnum::Active->value),
                ]),
                Section::make('Tags')->schema([
                    Select::make('tags')
                        ->relationship('tags', 'name')
                        ->multiple()
                        ->searchable()
                        ->preload(),
                ]),
            ]);
    }
}
