@php $editing = isset($equipment) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <x-inputs.text
            name="name"
            label="Name"
            :value="old('name', ($editing ? $equipment->name : ''))"
            maxlength="255"
            placeholder="Name"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.select
            name="manufacturer_id"
            label="Manufacturer"
            :value="old('manufacturer_id', ($editing ? $equipment?->manufacturer_id : ''))"
            placeholder="Manufacturer"
        >
            <option value="">---</option>
            @foreach($manufacturers as $item)
                <option
                    @if(isset($equipment) && $item->id===$equipment?->manufacturer_id)
                        selected="selected"
                    @endif
                    value="{{$item->id}}">{{$item->name}}</option>
            @endforeach

        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="serial_number"
            label="Serial number"
            :value="old('name', ($editing ? $equipment->serial_number : ''))"
            maxlength="255"
            placeholder="Serial number"
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.date
            name="purchase_date"
            label="Purchase Date"
            value="{{ old('purchase_date', ($editing ? optional($equipment->purchase_date)->format('Y-m-d') : '')) }}"
            max="255"
        ></x-inputs.date>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.textarea name="notes" label="Notes" maxlength="255"
            >{{ old('notes', ($editing ? $equipment->notes : ''))
            }}</x-inputs.textarea
        >
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.select
            name="location_id"
            label="Location"
            :value="old('location_id', ($editing ? $equipment?->location_id : ''))"
            placeholder="location"
        >
            @foreach($locations as $item)
                <option
                    @if(isset($location) && $item->id===$equipment?->location_id)
                        selected="selected"
                    @endif
                    value="{{$item->id}}">{{$item->name}}</option>
            @endforeach

        </x-inputs.select>
    </x-inputs.group>
</div>
