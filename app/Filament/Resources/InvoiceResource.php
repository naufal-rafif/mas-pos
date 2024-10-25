<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InvoiceResource\Pages;
use App\Models\Invoice;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Illuminate\Database\Eloquent\Builder;

class InvoiceResource extends Resource
{
    protected static ?string $model = Invoice::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    protected static ?string $navigationGroup = 'Sales Management';

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('order_id')
                    ->searchable()
                    ->sortable()
                    ->copyable(),
                TextColumn::make('transaction_date')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('total_amount')
                    ->money('IDR')
                    ->sortable(),
                TextColumn::make('products_count')
                    ->counts('products')
                    ->label('Total Items'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    //
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
    
    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Invoice Details')
                    ->schema([
                        TextEntry::make('order_id')
                            ->label('Order ID')
                            ->copyable(),
                        TextEntry::make('transaction_date')
                            ->dateTime(),
                        TextEntry::make('total_amount')
                            ->money('IDR'),
                        TextEntry::make('created_at')
                            ->dateTime(),
                    ])
                    ->columns(2),

                Section::make('Products')
                    ->schema([
                        RepeatableEntry::make('products')
                            ->schema([
                                TextEntry::make('name')
                                    ->label('Product Name'),
                                TextEntry::make('pivot.quantity')
                                    ->label('Quantity'),
                                TextEntry::make('pivot.price')
                                    ->money('IDR')
                                    ->label('Unit Price'),
                                TextEntry::make('subtotal')
                                    ->money('IDR')
                                    ->state(function ($record): float {
                                        return $record->pivot->price * $record->pivot->quantity;
                                    }),
                            ])
                            ->columns(4)
                    ])
            ]);
    }
    
    public static function getRelations(): array
    {
        return [
            //
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListInvoices::route('/'),
            'view' => Pages\ViewInvoice::route('/{record}'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['order_id'];
    }
}