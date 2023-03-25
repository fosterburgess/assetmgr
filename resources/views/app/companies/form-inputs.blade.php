@php $editing = isset($company) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <x-inputs.text
            name="name"
            label="Name"
            :value="old('name', ($editing ? $company->name : ''))"
            maxlength="255"
            placeholder="Name"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <div
            x-data="imageViewer('{{ $editing && $company->logo ? \Storage::url($company->logo) : '' }}')"
        >
            <x-inputs.partials.label
                name="logo"
                label="Logo"
            ></x-inputs.partials.label
            ><br />

            <!-- Show the image -->
            <template x-if="imageUrl">
                <img
                    :src="imageUrl"
                    class="object-cover rounded border border-gray-200"
                    style="width: 100px; height: 100px;"
                />
            </template>

            <!-- Show the gray box when image is not available -->
            <template x-if="!imageUrl">
                <div
                    class="border rounded border-gray-200 bg-gray-100"
                    style="width: 100px; height: 100px;"
                ></div>
            </template>

            <div class="mt-2">
                <input type="file" name="logo" id="logo" @change="fileChosen" />
            </div>

            @error('logo') @include('components.inputs.partials.error')
            @enderror
        </div>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="address1"
            label="Address1"
            :value="old('address1', ($editing ? $company->address1 : ''))"
            maxlength="255"
            placeholder="Address1"
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="address2"
            label="Address2"
            :value="old('address2', ($editing ? $company->address2 : ''))"
            maxlength="255"
            placeholder="Address2"
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="city"
            label="City"
            :value="old('city', ($editing ? $company->city : ''))"
            maxlength="255"
            placeholder="City"
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="state"
            label="State"
            :value="old('state', ($editing ? $company->state : ''))"
            maxlength="255"
            placeholder="State"
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="postal_code"
            label="Postal Code"
            :value="old('postal_code', ($editing ? $company->postal_code : ''))"
            maxlength="255"
            placeholder="Postal Code"
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="url1"
            label="Url1"
            :value="old('url1', ($editing ? $company->url1 : ''))"
            maxlength="255"
            placeholder="Url1"
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="url2"
            label="Instagram"
            :value="old('url2', ($editing ? $company->url2 : ''))"
            maxlength="255"
            placeholder="Instagram"
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="url3"
            label="Url3"
            :value="old('url3', ($editing ? $company->url3 : ''))"
            maxlength="255"
            placeholder="Url3"
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="email"
            label="Email"
            :value="old('email', ($editing ? $company->email : ''))"
            maxlength="255"
            placeholder="Email"
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="phone"
            label="Phone"
            :value="old('phone', ($editing ? $company->phone : ''))"
            maxlength="255"
            placeholder="Phone"
        ></x-inputs.text>
    </x-inputs.group>
</div>
