package customerdomain

import "context"

type Repository interface {
	GetCustomerById(ctx context.Context, id int) (res Customer, err error)
	GetCustomerList(ctx context.Context) (res []Customer, err error)
}

type Usecase interface {
	GetCustomerById(ctx context.Context, id int) (res CustomerResponse, err error)
	GetCustomerList(ctx context.Context) (res []CustomerListResponse, err error)
}
