Feature: Authenticaiton

    Scenario: Use the default authentication required by OneStock
        When I create the following parcel:
            """
            {
                "id": "1234",
                "date": 201901090000,
                "to": "shipped",
                "order_id": 1234,
                "line_item_ids": [ 1, 2, 3 ,4 ],
                "tracking_code": "1234"
            }
            """
        Then the API request should have the headers set:
            | Auth-Username-Header  | Auth-User      |
            | Auth-Password-Herader | Auth-Password  |

    Scenario: Use custom authentication required by OneStock
        Given the following extra parameters configured:
            | authentication_username_header | Custom-Username-Header |
            | authentication_password_header | Custom-Password-Header |
        When I create the following parcel:
            """
            {
                "id": "1234",
                "date": 201901090000,
                "to": "shipped",
                "order_id": 1234,
                "line_item_ids": [ 1, 2, 3 ,4 ],
                "tracking_code": "1234"
            }
            """
        Then the API request should have the headers set:
            | Auth-Username-Header  | Custom-Username-Header    |
            | Auth-Password-Herader | Custom-Password-Header    |
