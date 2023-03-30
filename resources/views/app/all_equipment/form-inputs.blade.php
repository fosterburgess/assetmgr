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
        <x-inputs.text
            name="serial_number"
            label="Serial Number"
            :value="old('serial_number', ($editing ? $equipment->serial_number : ''))"
            maxlength="255"
            placeholder="Serial Number"
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
</div>
