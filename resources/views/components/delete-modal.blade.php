@props(['entity', 'route'])

<div class="modal fade"
     id="delete-{{ $entity->slug }}"
     tabindex="-1"
     aria-labelledby="delete-{{ $entity->slug }}-label"
     aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="delete-{{ $entity->slug }}-label">
                    Elimina elemento
                </h5>

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Chiudi"></button>
            </div>

            <div class="modal-body text-center">
                Sei sicuro di voler eliminare
                <strong>{{ $entity->name }}</strong>?
                <br>
                [ id: <span class="badge bg-secondary">{{ $entity->id }}</span> 
                 - slug: <span class="badge bg-secondary">{{ $entity->slug }}</span> ] 
                <br><br>
                Questa azione <strong>non</strong> può essere annullata.
            </div>

            <div class="modal-footer">
                <button type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal">
                    Annulla
                </button>

                <form action="{{ route($route, $entity) }}"
                      method="POST">
                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn btn-danger">
                        Elimina definitivamente
                    </button>
                </form>
            </div>

        </div>
    </div>
</div>