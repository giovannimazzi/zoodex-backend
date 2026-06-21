@props(['entity', 'route'])

<div class="modal fade"
     id="delete-entity-{{ $entity->id }}"
     tabindex="-1"
     aria-labelledby="delete-entity-{{ $entity->id }}-label"
     aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="delete-entity-{{ $entity->id }}-label">
                    Elimina elemento
                </h5>

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Chiudi"></button>
            </div>

            <div class="modal-body">
                Sei sicuro di voler eliminare
                <strong>{{ $entity->name }}</strong>?
                <br>
                Questa azione non può essere annullata.
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