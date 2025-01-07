<div>
    <form wire:submit.prevent="save" enctype="multipart/form-data">
        <select wire:model="userOption" id="" class="form-control ">
            <option value="">Selecciona un usuario</option>
            @foreach($users as $user)
                <option value="{{$user->id}}" class="text-dark">{{$user->name}}</option>
            @endforeach
        </select>
        @error('userOption')
            <span class="text-danger">{{ $message }}</span>
        @enderror
        <input type="file" wire:model="file" class="form-control">
        @error('file')
            <span class="text-danger">{{ $message }}</span>
        @enderror
        <button type="submit">Importar</button>
    </form>
</div>
