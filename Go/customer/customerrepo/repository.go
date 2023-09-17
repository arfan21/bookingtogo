package customerrepo

import (
	"context"
	"fmt"

	"github.com/arfan21/bookingtogo/customer/customerdomain"
	"github.com/arfan21/bookingtogo/nationality/nationalitydomain"
	"github.com/jackc/pgx/v5/pgxpool"
)

type repository struct {
	db *pgxpool.Pool
}

func New(db *pgxpool.Pool) customerdomain.Repository {
	return &repository{db: db}
}

func (r *repository) GetCustomerById(ctx context.Context, id int) (res customerdomain.Customer, err error) {
	query := `SELECT
		customer.cst_id,
		cst_name,
		cst_dob,
		"cst_phoneNum",
		cst_email,
		nationality.national_id,
		national_name,
		national_code
	FROM
		customer
		JOIN nationality ON nationality.national_id = customer.national_id
	WHERE
		customer.cst_id = $1`

	rows, err := r.db.Query(ctx, query, id)
	if err != nil {
		err = fmt.Errorf("db: error when query get customer by id: %w", err)
		return
	}
	defer rows.Close()

	for rows.Next() {
		var nationality nationalitydomain.Nationality
		err = rows.Scan(
			&res.CstID,
			&res.CstName,
			&res.CstDOB,
			&res.CstPhoneNum,
			&res.CstEmail,
			&nationality.NationalID,
			&nationality.NationalName,
			&nationality.NationalCode,
		)

		if err != nil {
			err = fmt.Errorf("db: error when scan get customer by id: %w", err)
			return
		}

		res.Nationality = nationality
	}

	if rows.Err() != nil {
		err = fmt.Errorf("db: error when rows get customer by id: %w", err)
		return
	}

	return res, nil
}

func (r *repository) GetCustomerList(ctx context.Context) (res []customerdomain.Customer, err error) {
	query := `
	SELECT
		customer.cst_id,
		cst_name,
		cst_dob,
		"cst_phoneNum",
		cst_email
	FROM
		customer`

	rows, err := r.db.Query(ctx, query)
	if err != nil {
		err = fmt.Errorf("db: error when query get customer list: %w", err)
		return
	}
	defer rows.Close()

	for rows.Next() {
		var customer customerdomain.Customer
		err = rows.Scan(
			&customer.CstID,
			&customer.CstName,
			&customer.CstDOB,
			&customer.CstPhoneNum,
			&customer.CstEmail,
		)

		if err != nil {
			err = fmt.Errorf("db: error when scan get customer list: %w", err)
			return
		}

		res = append(res, customer)
	}

	if rows.Err() != nil {
		err = fmt.Errorf("db: error when rows get customer list: %w", err)
		return
	}

	return
}
