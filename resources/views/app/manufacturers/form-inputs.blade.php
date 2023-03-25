@php $editing = isset($manufacturer) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <x-inputs.text
            name="name"
            label="Name"
            :value="old('name', ($editing ? $manufacturer->name : ''))"
            maxlength="255"
            placeholder="Name"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.textarea
            name="description"
            label="Description"
            maxlength="255"
            >{{ old('description', ($editing ? $manufacturer->description : ''))
            }}</x-inputs.textarea
        >
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="url1"
            label="Url1"
            :value="old('url1', ($editing ? $manufacturer->url1 : ''))"
            maxlength="255"
            placeholder="Url1"
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="url2"
            label="Url2"
            :value="old('url2', ($editing ? $manufacturer->url2 : ''))"
            maxlength="255"
            placeholder="Url2"
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.email
            name="email"
            label="Email"
            :value="old('email', ($editing ? $manufacturer->email : ''))"
            maxlength="255"
            placeholder="Email"
        ></x-inputs.email>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="phone"
            label="Phone"
            :value="old('phone', ($editing ? $manufacturer->phone : ''))"
            maxlength="255"
            placeholder="Phone"
        ></x-inputs.text>
    </x-inputs.group>
</div>
