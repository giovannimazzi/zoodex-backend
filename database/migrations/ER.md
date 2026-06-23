erDiagram
USERS {
bigint id PK
string name
string email
timestamp email_verified_at
string password
string remember_token
timestamp created_at
timestamp updated_at
}

    ANIMALS {
        bigint id PK
        string name
        string slug
        string scientific_name
        text description
        decimal weight_kg
        decimal length_cm
        decimal height_cm
        integer lifespan_years
        string card_image
        string real_image
        bigint animal_class_id FK
        bigint diet_id FK
        bigint conservation_status_id FK
        timestamp created_at
        timestamp updated_at
    }

    ANIMAL_CLASSES {
        bigint id PK
        string name
        string slug
        text image
        string color
        text description
        timestamp created_at
        timestamp updated_at
    }

    DIETS {
        bigint id PK
        string name
        string slug
        text image
        string color
        text description
        timestamp created_at
        timestamp updated_at
    }

    CONSERVATION_STATUSES {
        bigint id PK
        string name
        string slug
        text image
        string color
        text description
        timestamp created_at
        timestamp updated_at
    }

    HABITATS {
        bigint id PK
        string name
        string slug
        text image
        string color
        text description
        timestamp created_at
        timestamp updated_at
    }

    CONTINENTS {
        bigint id PK
        string name
        string slug
        text image
        string color
        text description
        timestamp created_at
        timestamp updated_at
    }

    ABILITIES {
        bigint id PK
        string name
        string slug
        text image
        string color
        text description
        timestamp created_at
        timestamp updated_at
    }

    ANIMAL_HABITAT {
        bigint animal_id FK
        bigint habitat_id FK
    }

    ANIMAL_CONTINENT {
        bigint animal_id FK
        bigint continent_id FK
    }

    ABILITY_ANIMAL {
        bigint animal_id FK
        bigint ability_id FK
    }

    ANIMAL_CLASSES ||--o{ ANIMALS : classifica
    DIETS ||--o{ ANIMALS : alimenta
    CONSERVATION_STATUSES ||--o{ ANIMALS : conserva

    ANIMALS ||--o{ ANIMAL_HABITAT : vive_in
    HABITATS ||--o{ ANIMAL_HABITAT : contiene

    ANIMALS ||--o{ ANIMAL_CONTINENT : presente_in
    CONTINENTS ||--o{ ANIMAL_CONTINENT : ospita

    ANIMALS ||--o{ ABILITY_ANIMAL : possiede
    ABILITIES ||--o{ ABILITY_ANIMAL : appartiene_a
