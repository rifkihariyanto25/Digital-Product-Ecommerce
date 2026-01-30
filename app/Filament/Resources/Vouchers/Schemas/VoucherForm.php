<?php

namespace App\Filament\Resources\Vouchers\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Wizard;
use Filament\Schemas\Components\Wizard\Step;

class VoucherForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Wizard::make([
                    Step::make('Basic Information')
                        ->schema([
                            TextInput::make('kode_voucher')
                                ->label('Voucher Code')
                                ->required()
                                ->unique(ignoreRecord: true)
                                ->maxLength(255)
                                ->placeholder('SUKSES2025'),
                            
                            TextInput::make('nama_voucher')
                                ->label('Voucher Name')
                                ->required()
                                ->maxLength(255)
                                ->placeholder('Voucher Discount 20%'),
                        ]),

                    Step::make('Discount Settings')
                        ->schema([
                            Select::make('tipe')
                                ->label('Discount Type')
                                ->options([
                                    'persentase' => 'Percentage Discount',
                                    'nominal' => 'Nominal Discount',
                                ])
                                ->required()
                                ->default('persentase')
                                ->reactive()
                                ->helperText('Choose how the discount will be applied'),
                            
                            TextInput::make('nilai')
                                ->label('Discount Value')
                                ->numeric()
                                ->required()
                                ->default(0)
                                ->prefix(fn ($get) => $get('tipe') === 'nominal' ? 'Rp' : '')
                                ->suffix(fn ($get) => $get('tipe') === 'persentase' ? '%' : ''),
                            
                            TextInput::make('sebelumnya')
                                ->label('Sebelumnya')
                                ->disabled()
                                ->dehydrated(false),
                        ]),

                    Step::make('Usage Limits')
                        ->schema([
                            TextInput::make('batas_penggunaan')
                                ->label('Maximum Usage')
                                ->numeric()
                                ->required()
                                ->default(100)
                                ->helperText('Leave empty for unlimited usage'),
                            
                            TextInput::make('jumlah_terpakai')
                                ->label('Times Used')
                                ->numeric()
                                ->default(0)
                                ->disabled()
                                ->dehydrated(false)
                                ->helperText('Number of times this voucher has been used'),
                            
                            TextInput::make('sebelumnya')
                                ->label('Sebelumnya')
                                ->disabled()
                                ->dehydrated(false),
                        ]),

                    Step::make('Validity Period')
                        ->schema([
                            DatePicker::make('berlaku_dari')
                                ->label('Valid From')
                                ->required()
                                ->default(now())
                                ->helperText('Start date of voucher validity'),
                            
                            DatePicker::make('berlaku_sampai')
                                ->label('Valid Until')
                                ->required()
                                ->after('berlaku_dari')
                                ->helperText('End date of voucher validity'),
                            
                            Toggle::make('is_active')
                                ->label('Active Status')
                                ->default(true)
                                ->helperText('Toggle to enable or disable this voucher'),
                            
                            TextInput::make('sebelumnya')
                                ->label('Sebelumnya')
                                ->disabled()
                                ->dehydrated(false),
                        ]),
                ])
                ->columnSpanFull(),
            ]);
    }
}
