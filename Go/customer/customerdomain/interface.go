package customerdomain

import "context"

type Repository interface {
	GetCustomerById(ctx context.Context, id int) (res CustomerResponse, err error)
}

type Usecase interface {
	GetCustomerById(ctx context.Context, id int) (res CustomerResponse, err error)
}
