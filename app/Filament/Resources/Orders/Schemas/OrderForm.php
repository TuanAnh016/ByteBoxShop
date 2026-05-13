<?php

namespace App\Filament\Resources\Orders\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Repeater;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Order Information')
                    ->schema([
                        TextInput::make('code')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->default(fn () => 'ORD-' . strtoupper(uniqid())),
                        Select::make('status')
                            ->options([
                                'pending' => 'Pending',
                                'processing' => 'Processing',
                                'shipped' => 'Shipped',
                                'delivered' => 'Delivered',
                                'cancelled' => 'Cancelled',
                            ])
                            ->required()
                            ->default('pending'),
                        Select::make('user_id')
                            ->relationship('user', 'name')
                            ->searchable()
                            ->required(),
                        TextInput::make('total')
                            ->required()
                            ->numeric()
                            ->prefix('$')
                            ->default(0),
                    ])->columns(2),

                Section::make('Shipping Details')
                    ->schema([
                        TextInput::make('shipping_name'),
                        TextInput::make('shipping_phone')
                            ->tel(),
                        Textarea::make('shipping_address')
                            ->columnSpanFull(),
                        Textarea::make('note')
                            ->columnSpanFull(),
                    ])->columns(2),

                Section::make('Order Items')
                    ->schema([
                        Repeater::make('orderDetails')
                            ->relationship()
                            ->schema([
                                Select::make('product_id')
                                    ->relationship('product', 'name')
                                    ->required()
                                    ->disableOptionsWhenSelectedInSiblingRepeaterItems()
                                    ->columnSpan(2),
                                TextInput::make('quantity')
                                    ->numeric()
                                    ->default(1)
                                    ->required()
                                    ->columnSpan(1),
                                TextInput::make('price')
                                    ->numeric()
                                    ->required()
                                    ->columnSpan(1),
                            ])->columns(4)
                    ]),
            ]);
    }
}
