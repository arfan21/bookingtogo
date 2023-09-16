package familydomain

import "context"

type Repository interface {
	GetFamilyByCstID(ctx context.Context, cstID int) (res []FamilyResponse, err error)
}

type Usecase interface {
	GetFamilyByCstID(ctx context.Context, cstID int) (res []FamilyResponse, err error)
}
