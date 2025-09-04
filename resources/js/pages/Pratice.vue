<template>
    <div>
        <h1>Pratice</h1>
    </div>
</template>

<script setup lang="ts">

/*
What if an Order can contain more than one product (like a shopping cart)?
How would you change your Order type to allow that?
*/
    type Product = {
        id: number;
        name: string;
        price: number;
    }

    type Order = {
        productId: number;
        product: Product;
    }

    let order1: Order = {
        productId: 1,
        product: {
            id: 1,
            name: 'Product 1',
            price: 100,
        }
    }

    type ShoppingCart = {
        id: number;
        orders: Order[];
    }

    let car1: ShoppingCart = {
        id: 1,
        orders: [
            {
                productId: 1, 
                product: {
                    id: 1,
                    name: 'Laptop',
                    price: 1000,
                }
            },
            
            
        ]
    }

    async function example() {
        try {
            const res = await fetch('https://api.example.com/data');
            const data = await data.json();
        } catch (error) {
            console.error('Error:', error);
        } finally {
            console.log('Request completed');
        } 
    }

    type exs<T> = {
        
    }

</script>