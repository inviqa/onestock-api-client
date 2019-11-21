Feature: Exporting order
    In order to make the order fulfillment process more efficient
    As a warehouse administrator
    I should be able to send the order to OneStock

    Scenario: Successfully exporting an order with a single product
        Given the following order has been placed
            | id   | customer_first_name | customer_last_name | phone_number | email                 |
            | 1234 | Joe                 | Bloggs             | 01475 123456 | joa.bloggs@inviqa.com |
        And order with id "1234" contains the following line items
            | item_id |
            | 56      |
        When order 1234 is exported
        Then the export for order 1234 should be successful
