@php $editing = isset($contact) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <x-inputs.text
            name="name"
            label="Name"
            :value="old('name', ($editing ? $contact->name : ''))"
            maxlength="255"
            placeholder="Name"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.email
            name="email"
            label="Email"
            :value="old('email', ($editing ? $contact->email : ''))"
            maxlength="255"
            placeholder="Email"
        ></x-inputs.email>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="phone"
            label="Phone"
            :value="old('phone', ($editing ? $contact->phone : ''))"
            maxlength="255"
            placeholder="Phone"
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="mobile"
            label="Mobile"
            :value="old('mobile', ($editing ? $contact->mobile : ''))"
            maxlength="255"
            placeholder="Mobile"
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.textarea name="notes" label="Notes" maxlength="255"
            >{{ old('notes', ($editing ? $contact->notes : ''))
            }}</x-inputs.textarea
        >
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <div
            x-data="imageViewer('{{ $editing && $contact->avatar ? \Storage::url($contact->avatar) : '' }}')"
        >
            <x-inputs.partials.label
                name="avatar"
                label="Avatar"
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
                <input
                    type="file"
                    name="avatar"
                    id="avatar"
                    @change="fileChosen"
                />
            </div>

            @error('avatar') @include('components.inputs.partials.error')
            @enderror
        </div>
    </x-inputs.group>
</div>
